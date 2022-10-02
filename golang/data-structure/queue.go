package main

import (
	"fmt"
)

// NodeQueue ...定义链表节点
type NodeQueue struct {
	Value int
	Next  *NodeQueue
}

// 初始化队列
var sizeQueue = 0
var queue = new(NodeQueue)

// PushQueue ... 入队（从队头插入）
func PushQueue(t *NodeQueue, v int) bool {
	if queue == nil {
		queue = &NodeQueue{v, nil}
		sizeQueue++
		return true
	}

	t = &NodeQueue{v, nil}
	t.Next = queue
	queue = t
	sizeQueue++

	return true
}

// PopQueue ... 出队（从队尾删除）
func PopQueue(t *NodeQueue) (int, bool) {
	if sizeQueue == 0 {
		return 0, false
	}

	if sizeQueue == 1 {
		queue = nil
		sizeQueue--
		return t.Value, true
	}

	// 迭代队列，直到队尾
	temp := t
	for (t.Next) != nil {
		temp = t
		t = t.Next
	}

	v := (temp.Next).Value
	temp.Next = nil

	sizeQueue--
	return v, true
}

// traverseQueue ... 遍历队列所有节点
func traverseQueue(t *NodeQueue) {
	if sizeQueue == 0 {
		fmt.Println("空队列!")
		return
	}
	for t != nil {
		fmt.Printf("%d -> ", t.Value)
		t = t.Next
	}
	fmt.Println()
}

// 线性表之-队列
func main() {
	queue = nil
	// 入队
	PushQueue(queue, 10)
	fmt.Println("Size:", size)
	// 遍历
	traverseQueue(queue)

	// 出队
	v, b := PopQueue(queue)
	if b {
		fmt.Println("Pop:", v)
	}
	fmt.Println("Size:", size)

	// 批量入队
	for i := 0; i < 5; i++ {
		PushQueue(queue, i)
	}
	// 再次遍历
	traverseQueue(queue)
	fmt.Println("Size:", size)

	// 出队
	v, b = PopQueue(queue)
	if b {
		fmt.Println("Pop:", v)
	}
	fmt.Println("Size:", size)

	// 再次出队
	v, b = PopQueue(queue)
	if b {
		fmt.Println("Pop:", v)
	}
	fmt.Println("Size:", size)
	// 再次遍历
	traverseQueue(queue)
}
