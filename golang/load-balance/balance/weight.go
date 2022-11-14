package balance

import (
	"errors"
	"strconv"
)

// WeightBalance 负载均衡 - 权重
type WeightBalance struct {
	list []*WeightNode
}

type WeightNode struct {
	Service         string // 服务地址
	Weight          int64  // 初使约定的权重
	CurrentWeight   int64  // 临时权重，每轮都会有变化
	EffectiveWeight int64  // 有效权重，默认与Weight相同
}

func (w *WeightBalance) Add(params ...string) error {
	if len(params) < 2 {
		return errors.New("params could not be empty")
	}

	parseInt, err := strconv.ParseInt(params[1], 10, 64)
	if err != nil {
		return errors.New("convert to int error")
	}

	node := &WeightNode{
		Service:         params[0],
		Weight:          parseInt,
		CurrentWeight:   parseInt,
		EffectiveWeight: parseInt,
	}

	w.list = append(w.list, node)

	return nil
}

func (w *WeightBalance) Next() string {
	total := int64(0)
	var selected *WeightNode

	for index, v := range w.list {
		// 计算所有有效权重
		total += v.CurrentWeight

		// 修改当前服务器临时权重
		w.list[index].CurrentWeight += w.list[index].EffectiveWeight
		if v.EffectiveWeight < v.CurrentWeight {
			v.EffectiveWeight++
		}

		// 选中最大临时权重节点
		if selected == nil || selected.CurrentWeight < v.CurrentWeight {
			selected = v
		}
	}

	if selected == nil {
		return ""
	}

	// 变更临时权重为 临时权重 - 有效权重之和
	selected.CurrentWeight -= total

	return selected.Service
}

func (w *WeightBalance) Get(string) string {
	return w.Next()
}
