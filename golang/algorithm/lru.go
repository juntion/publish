package main

import "fmt"

// LinkNode 双向链表
type LinkNode struct {
	Key      int
	Value    int
	Previous *LinkNode
	Next     *LinkNode
}

// NodeCache hashmap 用于存储及快速查找数据在链表中的位置
type NodeCache struct {
	Size  int               // 当前存储数据长度
	Cap   int               // 可存储数据的容量
	Cache map[int]*LinkNode // hashmap
	Head  *LinkNode         // 伪头节点
	Tail  *LinkNode         // 伪尾节点
}

// InitLinkNode 链表初始化
func InitLinkNode(key, value int) *LinkNode {
	return &LinkNode{Key: key, Value: value}
}

// NewNodeCache hashmap初始化
func NewNodeCache(capacity int) *NodeCache {
	l := &NodeCache{
		Size:  0,
		Cap:   capacity,
		Cache: map[int]*LinkNode{},
		Head:  InitLinkNode(0, 0),
		Tail:  InitLinkNode(0, 0),
	}

	l.Head.Next = l.Tail
	l.Tail.Previous = l.Head

	return l
}

// RemoveNode 移除某个节点
func RemoveNode(node *LinkNode) {
	node.Previous.Next = node.Next
	node.Next.Previous = node.Previous
}

// RemoveTail 移除尾节点
func (nc *NodeCache) RemoveTail() *LinkNode {
	node := nc.Tail.Previous
	RemoveNode(node)

	return node
}

// AddHead 添加节点至头部
func (nc *NodeCache) AddHead(node *LinkNode) {
	node.Next = nc.Head.Next
	node.Previous = nc.Head
	nc.Head.Next.Previous = node
	nc.Head.Next = node
}

// MoveToHead 移动节点至头部
func (nc *NodeCache) MoveToHead(node *LinkNode) {
	RemoveNode(node)
	nc.AddHead(node)
}

// Get 获取某个key的数据
func (nc *NodeCache) Get(key int) int {
	if node, ok := nc.Cache[key]; ok {
		nc.MoveToHead(node)

		return node.Value
	}

	return -1
}

// Put 添加数据
func (nc *NodeCache) Put(key, value int) {
	if node, ok := nc.Cache[key]; ok {
		node.Value = value
		nc.MoveToHead(node)
	} else {
		newNode := InitLinkNode(key, value)
		nc.AddHead(newNode)
		nc.Cache[key] = newNode
		nc.Size++

		if nc.Size > nc.Cap {
			tail := nc.RemoveTail()
			nc.Size--
			delete(nc.Cache, tail.Key)
		}
	}
}

// LRU算法 - 最近最少使用缓存
func main() {
	n := NewNodeCache(3)
	n.Put(1, 1)
	n.Put(2, 2)
	fmt.Println(n.Get(2))
	n.Put(3, 3)
	n.Put(4, 4)
	n.Put(5, 5)
	fmt.Println(n.Get(5))
	fmt.Println(n.Get(2))
	fmt.Println(n.Get(1))
}
