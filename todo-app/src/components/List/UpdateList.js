import React, { useState, useEffect } from 'react';
import axios from 'axios';
import NavBar from '../Common/NavBar';
import { useNavigate, useParams } from 'react-router-dom';

function UpdateList() {
    const [name, setName] = useState('');
    const navigate = useNavigate();
    const token = sessionStorage.getItem('token');
    const { id } = useParams();

    const onSubmit = async (e) => {
        e.preventDefault();

        const config = {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                },
    };

    const body = JSON.stringify({ name });

    try {
        const response = await axios.patch(`http://127.0.0.1:8000/api/todolists/${id}`, body, config);
        if (response.status === 200) {

        alert("To Do List successfully updated");

        navigate('/showall');
        }
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
  }, [token, id]);

  return (
    <div>
      <NavBar />
      <h1>Update List</h1>
      <form onSubmit={onSubmit}>
        <label>
          List Name:
          <input type="text" value={name} onChange={(e) => setName(e.target.value)} required />
        </label>
        <button type="submit">Update List</button>
      </form>
    </div>
  );
}

export default UpdateList;
