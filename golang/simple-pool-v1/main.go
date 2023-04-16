package main

import (
	"fmt"
	"open/study/simple-pool/pool"
)

func main() {
	p, _ := pool.NewPool(3)

	for i := 0; i < 20; i++ {
		p.Put(pool.NewTask(func(v ...interface{}) error {
			fmt.Println(v)
			return nil
		}, []interface{}{i}))
	}

	p.Close()
}
