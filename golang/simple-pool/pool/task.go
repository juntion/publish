package pool

// Task 需执行的任务
type Task struct {
	f func() error
}

// NewTask 初始化
func NewTask(arg func() error) *Task {
	return &Task{
		f: arg,
	}
}

// Execute 执行
func (t *Task) Execute() {
	t.f()
}
