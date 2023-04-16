package pool

import (
	"errors"
	"log"
	"sync"
	"sync/atomic"
)

// Pool
// @Description 协程池
type Pool struct {
	capacity       uint32            // 池的容量
	runningWorkers uint32            // 正在运行的 worker(goroutine) 数量
	state          uint8             // 状态
	task           chan *Task        // 任务队列
	wg             sync.WaitGroup    // 协程管理官方包
	done           chan bool         // 安全关闭任务池
	panicHandler   func(interface{}) // 任务异常了捕获处理方法
}

// 池的状态枚举
const (
	RUNNING = 1
	STOPED  = 0
)

// NewPool
// @Description 池初始化
// @param capacity
// @return *Pool
// @return error
func NewPool(capacity uint32) (*Pool, error) {
	if capacity <= 0 {
		return nil, errors.New("invalid pool capacity")
	}

	return &Pool{
		capacity: capacity,
		state:    RUNNING,
		task:     make(chan *Task),
		done:     make(chan bool),
		wg:       sync.WaitGroup{},
	}, nil
}

// incRunning
// @Description 运行的协程数加一
func (p *Pool) incRunning() {
	atomic.AddUint32(&p.runningWorkers, 1)
}

// decRunning
// @Description 运行的协程数减一
func (p *Pool) decRunning() {
	atomic.AddUint32(&p.runningWorkers, ^uint32(0))
}

// GetRunningWorkers
// @Description 获取正在运行的协程数量
// @return uint32
func (p *Pool) GetRunningWorkers() uint32 {
	return atomic.LoadUint32(&p.runningWorkers)
}

// GetCapacity
// @Description 获取池的容量
// @return uint32
func (p *Pool) GetCapacity() uint32 {
	return atomic.LoadUint32(&p.capacity)
}

// Put
// @Description 将任务放入处理通道
// @param task
// @return error
func (p *Pool) Put(task *Task) error {
	if p.state == STOPED {
		return errors.New("pool already closed")
	}

	if p.GetRunningWorkers() < p.GetCapacity() {
		p.run()
	}

	p.task <- task

	return nil
}

// Close
// @Description 执行结束关闭
func (p *Pool) Close() {
	p.state = STOPED

	// 任务通道若为有缓冲区
	// 则为保安全关闭，等待所有的任务执行完
	/*for len(p.task) > 0 {

	}*/

	p.done <- true // 销毁 worker
	close(p.task)  // 关闭任务队列
	p.wg.Wait()    // 等待所有协程退出
}

// run
// @Description 启动协程 执行任务
func (p *Pool) run() {
	p.incRunning()
	p.wg.Add(1)
	go p.worker(&p.wg)
}

// worker
// @Description work子协程
// @param wg
func (p *Pool) worker(wg *sync.WaitGroup) {
	defer func() {
		p.decRunning()

		if r := recover(); r != nil {
			// 可以做些记录错误信息 然后重启一个子协程等
			p.panicHandler(func() {})
			wg.Done()
		}
	}()

	defer wg.Done()

	for {
		select {
		case task, ok := <-p.task:
			// 任务队列已关闭
			if !ok {
				return
			}

			err := task.Execute()
			if err != nil {
				log.Printf("task run err: %s\n", err)
			}
		case <-p.done:
			return
		}
	}
}
