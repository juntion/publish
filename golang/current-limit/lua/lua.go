package lua

import (
	"fmt"
	"github.com/go-redis/redis"
)

var luaScript = `
	local key         = KEYS[1]; -- 键 key
	local now_time    = ARGV[1]; -- 值 value
	local before_time = ARGV[2]; -- 间隔时间之前，纳秒
	local period      = ARGV[3]; -- 时间间隔，多少秒内，设置过期时间
	local requests    = ARGV[4]; -- 时间间隔内的请求次数
 
	redis.pcall("zadd", key, now_time, now_time); -- zset结构设置一个key，zadd(key,value,scores) 
	redis.pcall("zremrangebyscore", key, 0, before_time); -- 移除scores范围在0到bofore_time之间的值，即移除时间窗口之前的行为记录，剩下的都是时间窗口内的
	local count = redis.pcall("zcard", key); -- 获取窗口内的请求数量
	redis.pcall("expire", key, period); -- 设置 zset 过期时间，避免不活跃用户持续占用内存
	
	if tonumber(count) > tonumber(requests) then
		return 2;
	end
	return 1;`

func RunLua(client *redis.Client) (string, error) {
	evalSha, err := client.ScriptLoad(luaScript).Result()
	if err != nil {
		fmt.Println(err)
	}

	return evalSha, nil
}
