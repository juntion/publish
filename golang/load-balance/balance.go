package main

import (
	"fmt"
	"load-balance/balance"
)

func main() {
	b := balance.LoadBalanceFactory(3)
	b.Add("localhost:8080", "localhost:8081", "localhost:8082", "localhost:8083", "localhost:8085")

	//b.Add("localhost:8080", "2")
	//b.Add("localhost:8081", "2")
	//b.Add("localhost:8082", "6")
	//fmt.Println(b.Get())
	//fmt.Println(b.Get())
	//fmt.Println(b.Get())
	//fmt.Println(b.Get())
	//fmt.Println(b.Get())

	fmt.Println(b.Get("localhost:8080/hello"))
	fmt.Println(b.Get("localhost:8082/hello-1"))
	fmt.Println(b.Get("localhost:8085/hello"))
}
