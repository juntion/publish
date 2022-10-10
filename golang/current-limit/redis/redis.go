package redis

import "github.com/go-redis/redis"

type InitRedis struct {
	RDB *redis.Client
}

func NewInitRedis() *InitRedis {
	return &InitRedis{
		RDB: redis.NewClient(&redis.Options{
			Addr:     "127.0.0.1:6379",
			Password: "",
			DB:       0,
		}),
	}
}

func (r InitRedis) Nosql() *redis.Client {
	return r.RDB
}
