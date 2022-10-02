package main

import (
	"fmt"
)

// Node ... 定义节点
type Node struct {
	Value int
	Next  *Node
}

// 初始化头节点
var head = new(Node)

// addNode ... 添加节点
func addNode(t *Node, v int) int {
	if head == nil {
		t = &Node{v, nil}
		head = t
		return 0
	}

	if v == t.Value {
		fmt.Println("节点已存在:", v)
		return -1
	}

	// 如果当前节点下一个节点为空
	if t.Next == nil {
		t.Next = &Node{v, nil}
		return -2
	}

	// 如果当前节点下一个节点不为空
	return addNode(t.Next, v)
}

// traverse ... 遍历链表
func traverse(t *Node) {
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

// lookupNode ... 查找节点
func lookupNode(t *Node, v int) bool {
	if head == nil {
		t = &Node{v, nil}
		head = t
		return false
	}

	if v == t.Value {
		return true
	}

	if t.Next == nil {
		return false
	}

	return lookupNode(t.Next, v)
}

// size ... 获取链表长度
func size(t *Node) int {
	if t == nil {
		fmt.Println("-> 空链表!")
		return 0
	}

	i := 0
	for t != nil {
		i++
		t = t.Next
	}

	return i
}

// 线性表之-单链表
func main() {
	head = nil
	// 添加节点
	addNode(head, 1)
	addNode(head, -1)
	// 遍历
	traverse(head)
	// 添加更多节点
	addNode(head, 10)
	addNode(head, 5)
	addNode(head, 45)
	// 添加已存在节点
	addNode(head, 5)
	// 再次遍历
	traverse(head)

	// 查找已存在节点
	if lookupNode(head, 5) {
		fmt.Println("该节点已存在!")
	} else {
		fmt.Println("该节点不存在!")
	}

	// 查找不存在节点
	if lookupNode(head, -100) {
		fmt.Println("该节点已存在!")
	} else {
		fmt.Println("该节点不存在!")
	}
}
