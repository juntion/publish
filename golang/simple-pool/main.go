package main

import (
	"fmt"
	"simple-pool/pool"
)

func main() {
	task := func(i int) *pool.Task {
		return pool.NewTask(func() error {
			fmt.Println("finish parse ", i)

			return nil
		})
	}

	p := pool.NewPool(3)

	for i := 0; i < 100; i++ {
		p.Add(task(i))
	}

	p.Run()
}
