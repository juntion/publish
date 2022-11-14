package balance

type LoadBalance interface {
	Add(...string) error
	Next() string
	Get(string) string
}

type LoadInt int

const (
	Random LoadInt = iota
	RoundRobin
	Weight
	ConsistencyHash
)

func LoadBalanceFactory(loadInt LoadInt) LoadBalance {
	switch loadInt {
	case Random:
		return &RandomBalance{}
	case RoundRobin:
		return &RoundRobinBalance{}
	case Weight:
		return &WeightBalance{}
	case ConsistencyHash:
		return NewConsistencyHashBalance(10, nil)
	default:
		return &RandomBalance{}
	}
}
