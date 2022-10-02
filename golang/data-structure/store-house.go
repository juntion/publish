package main

import (
	"fmt"
)

// NodeStoreHouse ... 定义链表节点
type NodeStoreHouse struct {
	Value int
	Next  *NodeStoreHouse
}

// 初始化栈结构（空栈）
var sizeStoreHouse = 0
var stackStoreHouse = new(NodeStoreHouse)

// Push ... 进栈
func Push(v int) bool {
	// 空栈的话直接将值放入头节点即可
	if stackStoreHouse == nil {
		stackStoreHouse = &NodeStoreHouse{v, nil}
		sizeStoreHouse = 1
		return true
	}

	// 否则将插入节点作为栈的头节点
	temp := &NodeStoreHouse{v, nil}
	temp.Next = stackStoreHouse
	stackStoreHouse = temp
	sizeStoreHouse++
	return true
}

// Pop ... 出栈
func Pop(t *NodeStoreHouse) (int, bool) {
	// 空栈
	if sizeStoreHouse == 0 {
		return 0, false
	}

	// 只有一个节点
	if sizeStoreHouse == 1 {
		sizeStoreHouse = 0
		stackStoreHouse = nil
		return t.Value, true
	}

	// 将栈的头节点指针指向下一个节点，并返回之前的头节点数据
	stackStoreHouse = stackStoreHouse.Next
	sizeStoreHouse--
	return t.Value, true
}

// traverseStoreHouse ... 遍历（不删除任何节点，只读取值）
func traverseStoreHouse(t *NodeStoreHouse) {
	if sizeStoreHouse == 0 {
		fmt.Println("空栈!")
		return
	}

	for t != nil {
		fmt.Printf("%d -> ", t.Value)
		t = t.Next
	}
	fmt.Println()
}

// 线性表之-栈
func main() {
	stackStoreHouse = nil
	// 读取空栈
	v, b := Pop(stackStoreHouse)
	if b {
		fmt.Print(v, " ")
	} else {
		fmt.Println("Pop() 失败!")
	}

	// 进栈
	Push(100)
	// 遍历栈
	traverseStoreHouse(stackStoreHouse)
	// 再次进栈
	Push(200)
	// 再次遍历栈
	traverseStoreHouse(stackStoreHouse)

	// 批量进栈
	for i := 0; i < 10; i++ {
		Push(i)
	}

	// 批量出栈
	for i := 0; i < 15; i++ {
		v, b := Pop(stackStoreHouse)
		if b {
			fmt.Print(v, " ")
		} else {
			// 如果已经是空栈，则退出循环
			break
		}
	}

	fmt.Println()
	// 再次遍历栈
	traverseStoreHouse(stackStoreHouse)
}
