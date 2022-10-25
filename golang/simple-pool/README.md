### 简单的协程池

#### 可应用于日常跑脚本刷数据等

#### 缺点
1. 运行goroutine的任务结果未有接收
2. 运行goroutine的状态没有把控
3. goroutine在空闲时也需要占用系统资源
4. goroutine异常后没有补充
5. 最好能回收goroutine 并发过载保护等