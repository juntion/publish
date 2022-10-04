package logic

import (
	"fmt"
	"github.com/go-redis/redis"
	"math/rand"
	"seckill/lua"
	"strconv"
	"time"
)

var luaScript = `
			local userId   = KEYS[1];
			local goodKey  = KEYS[2];
			local stock    = KEYS[3];
			local userExit = redis.call("sismember",goodKey,userId);
            if tonumber(userExit) == 1 then
                return 2;
            end 
            local num = redis.call("get",stock);
            if tonumber(num) <= 0 then
                return 3;
            else
                redis.call("decr",stock);
                redis.call("sadd",goodKey,userId);
            end 
            return 1;`

func SecKill(client *redis.Client) {
	errStock := client.SetNX("go_stock", 1000, 0).Err()
	if errStock != nil {
		panic(errStock)
	}

	rand.Seed(time.Now().UnixNano()) // 毫秒
	id := rand.Intn(990001) + 10000  // 10000-1000000的随机数
	// lua脚本
	evalSha, errLua := lua.RunLua(client, luaScript)
	if errLua != nil {
		panic(errLua)
	}
	userId := strconv.Itoa(id) // 整数转字符，如果直接int(id)会出现意想不到的结果
	res, err2 := client.EvalSha(evalSha, []string{userId, "go_user_ids", "go_stock"}).Result()
	if err2 != nil {
		panic(err2)
	}
	if res.(int64) == int64(1) {
		fmt.Println("秒杀成功")
	} else if res.(int64) == int64(2) {
		fmt.Println("请勿重复操作")
	} else {
		fmt.Println("暂无库存了")
	}
}
