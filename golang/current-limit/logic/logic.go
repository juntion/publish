package logic

import (
	"current-limit/lua"
	"fmt"
	"github.com/go-redis/redis"
	"time"
)

// 成功的次数
var successSort = 0

func DoRequest(client *redis.Client) {
	success := isPermitted("nothing", "add/Cart", 3, 10, client)
	if success {
		successSort++
		fmt.Println("成功", successSort) // 处理业务逻辑
	} else {
		fmt.Println("失败")
	}
}

func isPermitted(uid string, action string, period, maxCount int, client *redis.Client) bool {
	key := fmt.Sprintf("%v_%v", uid, action)
	now := time.Now().UnixNano() // 纳秒
	beforeTime := now - int64(period*1000000000)
	// lua脚本
	evalSha, _ := lua.RunLua(client)
	res, err := client.EvalSha(evalSha, []string{key}, now, beforeTime, period, maxCount).Result()
	if err != nil {
		panic(err)
	}
	if res.(int64) == int64(2) {
		return false
	}

	return true
}
