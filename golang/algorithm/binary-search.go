package main

import (
	"fmt"
	"sort"
)

// binarySearch ... 二分查找法
func binarySearch(nums []int, num, low, high int) int {
	// 递归终止条件
	if low > high {
		return -1
	}

	mid := (low + high) / 2
	// 递归查找
	if num > nums[mid] {
		return binarySearch(nums, num, mid+1, high)
	} else if num < nums[mid] {
		return binarySearch(nums, num, low, mid-1)
	} else {
		return mid

		// 查找第一个匹配元素
		/*if mid == 0 || nums[mid-1] != num {
			return mid
		} else {
			return binarySearch(nums, num, low, mid-1)
		}*/

		// 查找最后一个匹配元素
		/*if mid == len(nums)-1 || nums[mid+1] != num {
			return mid
		} else {
			return binarySearch(nums, num, mid+1, high)
		}*/
	}
}

func main() {
	nums := []int{30, 26, 10, 23, 5, 8, 12, 1, 16}
	sort.Ints(nums)

	num := 26
	index := binarySearch(nums, num, 0, len(nums)-1)
	if index != -1 {
		fmt.Printf("Find num %d at index %d\n", num, index)
	} else {
		fmt.Printf("Num %d not exists in nums\n", num)
	}
}
