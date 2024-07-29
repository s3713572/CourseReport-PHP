import * as React from 'react';
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

function createData(student_name, math, english, physics) {
  return { student_name, math, english, physics };
}

const rows = [
  createData('Bob', 159, 6.0, 24, 4.0),
  createData('Joey', 237, 9.0, 37, 4.3),
  createData('Alan', 262, 16.0, 24, 6.0),
  createData('Harry', 305, 3.7, 67, 4.3),
  createData('Patrick', 356, 16.0, 49, 3.9),
];

const CourseReportTable = () => {
  const [searchInput, setSearchInput] = useState("")

  const handleInputChange = (event) => {
    setSearchInput(event.target.value);
  };

  const handleSearch = () => {
    alert("成了" + searchInput)
    enrolmentsReport()
  }

  return (
    <>
      <Paper
        component="form"
        sx={{ p: '2px 4px', display: 'flex', alignItems: 'center', width: 400, boxShadow: 5, marginBottom: 2 }}
      >
        <InputBase
          sx={{ ml: 1, flex: 1 }}
          placeholder="Search student"
          inputProps={{ 'aria-label': 'search student' }}
          onChange={handleInputChange}
          value={searchInput}
        />
        <IconButton type="button" sx={{ p: '10px' }} aria-label="search" onClick={handleSearch}>
          <SearchIcon/>
        </IconButton>
      </Paper>
      <TableContainer component={Paper} sx={{boxShadow: 5}}>
        <Table sx={{ minWidth: 700}} aria-label="customized table">
          <TableHead>
            <TableRow>
              <StyledTableCell>Student Name</StyledTableCell>
              <StyledTableCell align="right">Math</StyledTableCell>
              <StyledTableCell align="right">English</StyledTableCell>
              <StyledTableCell align="right">Physics</StyledTableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {rows.map((row) => (
              <StyledTableRow key={row.student_name}>
                <StyledTableCell component="th" scope="row">
                  {row.student_name}
                </StyledTableCell>
                <StyledTableCell align="right">{row.math}</StyledTableCell>
                <StyledTableCell align="right">{row.english}</StyledTableCell>
                <StyledTableCell align="right">{row.physics}</StyledTableCell>
              </StyledTableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </>

  )
}

export default CourseReportTable