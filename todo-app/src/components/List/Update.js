import React, { useState, useEffect } from 'react';
import axios from 'axios';
import NavBar from '../Common/NavBar';
import { useNavigate, useParams } from 'react-router-dom';

function Update() {
  const { id } = useParams();
  const token = sessionStorage.getItem('token');
  const navigate = useNavigate();   

  const [name, setName] = useState('');

  const updateListName = async (e) => {
    e.preventDefault();

    const config = {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
    };

    const body = JSON.stringify({ name });

    try {
      await axios.patch(`http://127.0.0.1:8000/api/todolists/${listid}`, body, config);
        alert("To Do List successfully updated");
        navigate('/showall');
    } catch (error) {
      console.error('An error occurred while updating the list:', error);
    }
  };

  useEffect(() => {
    const fetchList = async () => {
      try {
        const response = await axios({
          method: 'get',
          url: `http://127.0.0.1:8000/api/todolists/${id}`,
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        setName(response.data.name);
      } catch (error) {
        console.error('An error occurred while fetching the list:', error);
      }
    };

    fetchList();
  }, [token, listid]);

  return (
    <div>
      <NavBar />
      <h1>Update List</h1>
      <form onSubmit={updateListName}>
        <label>
          List Name:
          <input type="text" value={name} onChange={(e) => setName(e.target.value)} required />
        </label>
        <button type="submit">Update List</button>
      </form>
    </div>
  );
}

export default Update;
