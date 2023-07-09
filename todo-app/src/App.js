import React from 'react';
import './App.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';  

import Login    from './components/User/Login';
import Register from './components/User/Register' ;
import ShowAll  from './components/List/ShowAll' ;
import Create   from './components/List/Create' ;
import AddItem   from './components/List/AddItem' ;

function App() {
  return (
    <Router>
        <Routes>
          <Route path='/'             element={<Login />} />
          <Route path='/register'     element={<Register />} />
          <Route path='/create'       element={<Create />} />
          <Route path='/showall'      element={<ShowAll />} />
          <Route path='/additem/:id'  element={<AddItem />} />
        </Routes>
    </Router>
  );
}

export default App;
