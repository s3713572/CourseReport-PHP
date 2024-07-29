import axios from './request';

export function enrolmentsReport(params) {
  return axios.get('/api/enrolments/', { params });
}
