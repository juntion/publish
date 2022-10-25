package pool

import (
	"fmt"
	"sync"
)

// Pool 协程池
type Pool struct {
	workNum int
	task    chan *Task
	wg      sync.WaitGroup
}

// NewPool 池初始化
func NewPool(cap int) *Pool {
	p := &Pool{
		workNum: cap,
		task:    make(chan *Task),
		wg:      sync.WaitGroup{},
	}

	p.initialize()

	return p
}

func (p *Pool) initialize() {
	p.wg.Add(p.workNum)

	for i := 0; i < p.workNum; i++ {
		go p.worker(i, &p.wg)
	}
}

// Run 等待任务执行完成
func (p *Pool) Run() {
	close(p.task)
	p.wg.Wait()
}

// worker goroutine执行任务
func (p *Pool) worker(workerId int, wg *sync.WaitGroup) {
	defer func() {
		if r := recover(); r != nil {
			wg.Done()
		}
	}()

	for task := range p.task {
		task.Execute()
	}

	fmt.Println("workerId: ", workerId, "执行任务完毕!")

	wg.Done()
}

// Add 添加任务
func (p *Pool) Add(fn *Task) {
	p.task <- fn
}
