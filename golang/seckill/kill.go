package main

import (
	"github.com/gin-gonic/gin"
	"net/http"
	"seckill/logic"
	"seckill/redis"
)

func main() {
	redisDb := redis.InitRedis()
	// 1.创建路由
	r := gin.Default()
	// 2.绑定路由规则，执行的函数
	// gin.Context，封装了request和response
	r.GET("/kill", func(c *gin.Context) {
		logic.SecKill(redisDb)
		c.String(http.StatusOK, "秒杀成功")
	})

	// 3.监听端口，默认在8080
	// Run("里面不指定端口号默认为8080")
	r.Run(":8000")
}
