import * as React from 'react';
import { useEffect } from 'react';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell, { tableCellClasses } from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import { styled } from '@mui/material/styles';
import InputBase from '@mui/material/InputBase';
import IconButton from '@mui/material/IconButton';
import SearchIcon from '@mui/icons-material/Search';
import { useState } from 'react';
import { enrolmentsReport } from '../api/enrolments.api'
import Pagination from '@mui/material/Pagination';
import Stack from '@mui/material/Stack';

import Box from '@mui/material/Box';
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';
import CssBaseline from '@mui/material/CssBaseline';


const StyledTableCell = styled(TableCell)(({ theme }) => ({
  [`&.${tableCellClasses.head}`]: {
    backgroundColor: theme.palette.common.black,
    color: theme.palette.common.white,
  },
  [`&.${tableCellClasses.body}`]: {
    fontSize: 14,
  },
}));

const StyledTableRow = styled(TableRow)(({ theme }) => ({
  '&:nth-of-type(odd)': {
    backgroundColor: theme.palette.action.hover,
  },
  // hide last border
  '&:last-child td, &:last-child th': {
    border: 0,
  },
}));

const CourseReportTable = () => {
  const [enrolments, setEnrolments] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [searchInput, setSearchInput] = useState("")

  const [page, setPage] = useState(1);
  const [totalPages, setTotalPages] = useState(0);
  const perPage = 10

  const [status, setStatus] = React.useState('');
  const [searchBtnTrigger, setSearchBtnTrigger] = useState(true);

  const [course, setCourse] = React.useState('');

  useEffect(() => {
    // get filtered data
    const fetchEnrolments = async () => {
      try {
        const response = await enrolmentsReport({ page, per: perPage, search: searchInput, course: course, status: status });
        setEnrolments(response.data.enrolments);
        setTotalPages(response.meta.total);
      } catch (err) {
        console.error('Error fetching enrolments:', err);
        setError(err);
      } finally {
        setLoading(false);
      }
    }
    fetchEnrolments();
  }, [page, searchBtnTrigger, course, status])

  if (loading) return <div>Loading...</div>;
  if (error) return <div>Error: {error.message}</div>;

  const handlePageChange = (event, value) => {
    setPage(value);
  };

  const handleInputChange = (event) => {
    setSearchInput(event.target.value);
  };

  const handleSearch = () => {
    setSearchBtnTrigger(prevState => !prevState)
  }

  const handleStatusSelectionChange = (event) => {
    setStatus(event.target.value);
    console.log(event.target.value)
  };

  const handleCourseSelectionChange = (event) => {
    setCourse(event.target.value);
    console.log(event.target.value)
  };

  const getCircleStyle = (status) => {
    switch (status) {
      case 'completed':
        return { backgroundColor: 'green' };
      case 'not_started':
        return { backgroundColor: 'red' };
      case 'in_progress':
        return { backgroundColor: 'yellow' };
      default:
        return { backgroundColor: 'gray' }; // 默认颜色
    }
  };

  return (
    <>
      <h1>Enrolments Report</h1>
      <div style={{display: "flex"}}>

      <Paper
        component="form"
        sx={{ p: '2px 4px', display: 'flex', alignItems: 'center', width: 400, boxShadow: 5, marginBottom: 2 }}
      >
        <InputBase
          sx={{ ml: 1, flex: 1 }}
          placeholder="Search student first name"
          inputProps={{ 'aria-label': 'search student' }}
          onChange={handleInputChange}
          value={searchInput}
        />
        <IconButton type="button" sx={{ p: '10px' }} aria-label="search" onClick={handleSearch}>
          <SearchIcon />
        </IconButton>
      </Paper>
      <Box sx={{ minWidth: 140, marginTop: '-6px', marginLeft: '60px'}}>
        <FormControl fullWidth>
          <InputLabel id="demo-simple-select-label">Course</InputLabel>
          <Select
            labelId="demo-simple-select-label"
            id="demo-simple-select"
            value={course}
            label="Completion Status"
            onChange={handleCourseSelectionChange}
          >
            <MenuItem value="default_all">Default(all)</MenuItem>
            <MenuItem value="Math">Math</MenuItem>
            <MenuItem value="English">English</MenuItem>
            <MenuItem value="Physics">Physics</MenuItem>
          </Select>
        </FormControl>
      </Box>
      <Box sx={{ minWidth: 220, marginTop: '-6px', marginLeft: '60px'}}>
        <FormControl fullWidth>
          <InputLabel id="demo-simple-select-label">Completion Status</InputLabel>
          <Select
            labelId="demo-simple-select-label"
            id="demo-simple-select"
            value={status}
            label="Completion Status"
            onChange={handleStatusSelectionChange}
          >
            <MenuItem value="default_all">Default(all)</MenuItem>
            <MenuItem value="completed">completed</MenuItem>
            <MenuItem value="in_progress">in_progress</MenuItem>
            <MenuItem value="not_started">not_started</MenuItem>
          </Select>
        </FormControl>
      </Box>
      </div>

      <TableContainer component={Paper} sx={{ boxShadow: 5 }}>
        <Table sx={{ minWidth: 700 }} aria-label="customized table">
          <TableHead>
            <TableRow>
              <StyledTableCell>First Name</StyledTableCell>
              <StyledTableCell align="left">Surname</StyledTableCell>
              <StyledTableCell align="left">Course</StyledTableCell>
              <StyledTableCell align="left">Completion Status</StyledTableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {enrolments.map((enrolment) => (
              <StyledTableRow>
                <StyledTableCell component="th" scope="row">
                  {enrolment.first_name}
                </StyledTableCell>
                <StyledTableCell align="left">{enrolment.surname}</StyledTableCell>
                <StyledTableCell align="left">{enrolment.course_description}</StyledTableCell>
                <StyledTableCell align="right">
                  <div style={{ display: 'flex' }}>
                    <div style={{ width: '10px', height: '10px', borderRadius: '50%', ...getCircleStyle(enrolment.completion_status), marginRight: '12px', marginTop: '6px' }} />
                    {enrolment.completion_status}
                  </div>
                </StyledTableCell>
              </StyledTableRow>
            ))}
          </TableBody>
        </Table>

      </TableContainer>
      <Stack sx={{ marginTop: 5, marginLeft: -1 }}>
        <Pagination
          color="primary"
          count={totalPages}
          page={page}
          onChange={handlePageChange}
          variant="outlined"
          shape="rounded"
        />
      </Stack>
    </>

  )
}

export default CourseReportTable