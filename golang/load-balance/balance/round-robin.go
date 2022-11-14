package balance

import (
	"errors"
)

// RoundRobinBalance 负载均衡 - 轮询
type RoundRobinBalance struct {
	curIndex int      // 需要用到的对应服务器下标
	service  []string // 服务器地址
}

func (r *RoundRobinBalance) Add(params ...string) error {
	if len(params) == 0 {
		return errors.New("params could not be empty")
	}

	r.service = append(r.service, params...)

	return nil
}

func (r *RoundRobinBalance) Next() string {
	if len(r.service) == 0 {
		return ""
	}

	l := len(r.service)

	if r.curIndex >= l {
		r.curIndex = 0
	}

	res := r.service[r.curIndex]
	r.curIndex = (r.curIndex + 1) % l

	return res
}

func (r *RoundRobinBalance) Get(string) string {
	return r.Next()
}
