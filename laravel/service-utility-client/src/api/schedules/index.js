import axios from '../../plugins/axios'

export const getSchedules = (year, month) => {
  return axios.get('/schedules/' + year + '/' + month)
}

export const editSchedules = (id, params) => {
  return axios.patch('/schedules/' + id, params)
}
