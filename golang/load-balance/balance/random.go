package balance

import (
	"errors"
	"math/rand"
	"time"
)

// RandomBalance 负载均衡 - 随机分配
type RandomBalance struct {
	curIndex int      // 需要用到的对应服务器下标
	service  []string // 服务器地址
}

func (r *RandomBalance) Add(params ...string) error {
	if len(params) == 0 {
		return errors.New("params could not be empty")
	}

	r.service = append(r.service, params...)

	return nil
}

func (r *RandomBalance) Next() string {
	if len(r.service) == 0 {
		return ""
	}

	// 随机种子，否则运行环境相同是 rand.Intn() 方法获取到的随机数不会发生改变
	rand.Seed(time.Now().Unix())
	r.curIndex = rand.Intn(len(r.service))

	return r.service[r.curIndex]
}

func (r *RandomBalance) Get(string) string {
	return r.Next()
}
