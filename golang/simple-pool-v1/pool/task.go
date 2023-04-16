package pool

// Task
// @Description 需要处理的任务
type Task struct {
	Handler func(p ...interface{}) error
	Params  []interface{}
}

// NewTask
// @Description 初始化
// @param arg
// @param p
// @return *Task
func NewTask(arg func(v ...interface{}) error, p []interface{}) *Task {
	return &Task{
		Handler: arg,
		Params:  p,
	}
}

// Execute
// @Description 执行任务
// @return error
func (t *Task) Execute() error {
	return t.Handler(t.Params...)
}
