import React, { useState } from 'react';
import axios from 'axios';
import NavBar  from '../Common/NavBar';
import { useNavigate } from 'react-router-dom';

function Create() {
  const [listName, setListName] = useState('');
  const token = sessionStorage.getItem('token');
  const navigate = useNavigate(); 

  const handleSubmit = async (event) => {
    event.preventDefault();
    try {
      const response = await axios({
        method: 'post',
        url: 'http://127.0.0.1:8000/api/todolists',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
        data: {
          name: listName,
        },
      });
      if (response.status === 201) {
        // Clear the input field after successful submission
        setListName('');
        alert("List created successfully!");
        navigate('/showall');
      }
    } catch (error) {
      console.error('An error occurred while creating the list:', error);
    }
  };

  const handleChange = (event) => {
    setListName(event.target.value);
  };

  return (
    <div>
      <NavBar />
      <div className="container">
        <h2>Create a new list</h2> 
        <form onSubmit={handleSubmit}>
          <label>
            List Name:
            <input type="text" value={listName} onChange={handleChange} required />
          </label>
          <input type="submit" value="Create List" />
        </form>
      </div>
    </div>
  );
}

export default Create;
