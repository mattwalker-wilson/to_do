import React, { useState } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';

function AddItem() {
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    completed: 0
  });

  const { title, description, completed } = formData;
  const navigate = useNavigate(); 
  const token = sessionStorage.getItem('token');
  const { id } = useParams();

  const onChange = e => setFormData({ ...formData, [e.target.name]: e.target.value });

  const onSubmit = async e => {
    e.preventDefault();

    const config = {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
    };
    
    const body = JSON.stringify({ title, description, completed });

    try {
      const response = await axios.post(`http://127.0.0.1:8000/api/todolists/${id}/todoitems`, body, config);
      if (response.status === 201) {
        // Clear the input field after successful submission
        setFormData({
          title: '',
          description: '',
          completed: 0
        });

        alert("To Do List Item successfully added");

        navigate('/showall');
      }
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div>
      <h1>Add Item to List {id} </h1>
      <form onSubmit={e => onSubmit(e)}>
        <div>
          <input 
            type="text" 
            placeholder="Title" 
            name="title" 
            value={title} 
            onChange={e => onChange(e)} 
            required 
          />
        </div>
        <div>
          <textarea 
            placeholder="Description" 
            name="description" 
            value={description} 
            onChange={e => onChange(e)} 
          />
        </div>
        <div>
          <label>
            Completed:
            <input 
              type="checkbox" 
              name="completed" 
              checked={completed} 
              onChange={e => onChange(e)} 
            />
          </label>
        </div>
        <input type="submit" value="Add Item" />
      </form>
    </div>
  );
}

export default AddItem;
