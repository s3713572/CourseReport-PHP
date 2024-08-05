import axios from './request';

// get all records
export function enrolmentsReport(params) {
  return axios.get('/api/enrolments/', { params });
}
