package lua

import (
	"fmt"
	"github.com/go-redis/redis"
)

func RunLua(client *redis.Client, luaScript string) (string, error) {
	evalSha, err := client.ScriptLoad(luaScript).Result()
	if err != nil {
		fmt.Println(err)
	}

	return evalSha, nil
}
