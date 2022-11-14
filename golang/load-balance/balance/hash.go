package balance

import (
	"errors"
	"hash/crc32"
	"sort"
	"strconv"
	"sync"
)

type Hash func([]byte) uint32

type Uint32Slice []uint32

func (s Uint32Slice) Len() int {
	return len(s)
}

func (s Uint32Slice) Less(i, j int) bool {
	return s[i] < s[j]
}

func (s Uint32Slice) Swap(i, j int) {
	s[i], s[j] = s[j], s[i]
}

// ConsistencyHashBalance 负载均衡 - 一致性hash
type ConsistencyHashBalance struct {
	hash     Hash              // hash函数
	replicas int               // 复制因子
	keys     Uint32Slice       // 已排序的hash节点切片
	hashMap  map[uint32]string // key为hash值，val为节点
	mux      sync.RWMutex
}

func NewConsistencyHashBalance(replicas int, hash Hash) *ConsistencyHashBalance {
	c := &ConsistencyHashBalance{
		hash:     hash,
		replicas: replicas,
		keys:     make([]uint32, 0, 100),
		hashMap:  make(map[uint32]string),
	}

	if c.hash == nil {
		// 保证是一个 2^32-1 的一个环
		c.hash = crc32.ChecksumIEEE
	}

	return c
}

func (c *ConsistencyHashBalance) Add(params ...string) error {
	if len(params) == 0 {
		return errors.New("params could not be empty")
	}

	c.mux.Lock()
	defer c.mux.Unlock()

	// 结合复制因子计算所有虚拟节点的hash值并保存在keys中
	// 同时在hashMap中保存hash值与服务器地址的映射
	for _, addr := range params {
		for i := 0; i < c.replicas; i++ {
			hash := c.hash([]byte(strconv.Itoa(i) + addr))
			c.keys = append(c.keys, hash)
			c.hashMap[hash] = addr
		}
	}

	// 对所有虚拟节点的hash值进行排序，方便之后的二分查找
	sort.Sort(c.keys)

	return nil
}

func (c *ConsistencyHashBalance) Next() string {
	return ""
}

func (c *ConsistencyHashBalance) Get(s string) string {
	if len(c.keys) == 0 {
		return ""
	}

	// 计算hash值
	hash := c.hash([]byte(s))

	// 通过二分查找获取到节点，再找到服务器节点
	index := sort.Search(len(c.keys), func(i int) bool {
		return c.keys[i] >= hash
	})

	// 没有找到服务器，说明此时处于环的尾部，那么直接用第0台服务器
	if index == len(c.keys) {
		index = 0
	}

	c.mux.Lock()
	defer c.mux.Unlock()

	return c.hashMap[c.keys[index]]
}
