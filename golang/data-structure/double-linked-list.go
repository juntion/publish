package main

import (
	"fmt"
)

// DNode ... 定义节点
type DNode struct {
	Value    int
	Previous *DNode
	Next     *DNode
}

// addDNode ... 添加节点
func addDNode(t *DNode, v int) int {
	if headD == nil {
		t = &DNode{v, nil, nil}
		headD = t
		return 0
	}

	if v == t.Value {
		fmt.Println("节点已存在:", v)
		return -1
	}

	// 如果当前节点下一个节点为空
	if t.Next == nil {
		// 与单链表不同的是每个节点还要维护前驱节点指针
		temp := t
		t.Next = &DNode{v, temp, nil}
		return -2
	}

	// 如果当前节点下一个节点不为空
	return addDNode(t.Next, v)
}

// traverseDouble ... 遍历链表
func traverseDouble(t *DNode) {
	if t == nil {
		fmt.Println("-> 空链表!")
		return
	}

	for t != nil {
		fmt.Printf("%d -> ", t.Value)
		t = t.Next
	}

	fmt.Println()
}

// traverseDouble ... 反向遍历链表
func reverseDouble(t *DNode) {
	if t == nil {
		fmt.Println("-> 空链表!")
		return
	}

	temp := t
	for t != nil {
		temp = t
		t = t.Next
	}

	for temp.Previous != nil {
		fmt.Printf("%d -> ", temp.Value)
		temp = temp.Previous
	}

	fmt.Printf("%d -> ", temp.Value)
	fmt.Println()
}

// sizeDouble ... 获取链表长度
func sizeDouble(t *DNode) int {
	if t == nil {
		fmt.Println("-> 空链表!")
		return 0
	}

	n := 0
	for t != nil {
		n++
		t = t.Next
	}

	return n
}

// lookupDNode ... 查找节点
func lookupDNode(t *DNode, v int) bool {
	if head == nil {
		return false
	}

	if v == t.Value {
		return true
	}

	if t.Next == nil {
		return false
	}

	return lookupDNode(t.Next, v)
}

// 初始化头节点
var headD = new(DNode)

// 线性表之-双向链表
func main() {
	headD = nil
	// 新增节点
	addDNode(headD, 1)
	// 遍历
	traverseDouble(headD)
	// 继续添加节点
	addDNode(headD, 10)
	addDNode(headD, 5)
	addDNode(headD, 100)
	// 再次遍历
	traverseDouble(headD)
	// 添加已存在节点
	addDNode(headD, 100)
	fmt.Println("链表长度:", sizeDouble(headD))
	// 再次遍历
	traverseDouble(headD)
	// 反向遍历
	reverseDouble(headD)

	// 查找已存在节点
	if lookupDNode(headD, 5) {
		fmt.Println("该节点已存在!")
	} else {
		fmt.Println("该节点不存在!")
	}
}
