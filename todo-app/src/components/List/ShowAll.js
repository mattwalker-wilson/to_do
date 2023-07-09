import React, { useState, useEffect   } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import NavBar  from '../Common/NavBar';

function ShowAll() {
  const [lists, setLists] = useState([]);
  const token = sessionStorage.getItem('token');

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios({
          method: 'get',
          url: 'http://127.0.0.1:8000/api/todolists',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        });
        setLists(response.data);
      } catch (error) {
        console.error('An error occurred while fetching the lists:', error);
      }
    };

    fetchData();
  }, [token]);

  return (
    <div>
      <NavBar />
      {lists.map(list => (
        <div key={list.id}>
          <h2>
            {list.name} 
            &nbsp;
            <Link to={`/additem/${list.id}`}>Add Item to list</Link>
          </h2>
          <ol>
            {list.to_do_items.map(item => (
              <li key={item.id}>{item.title} - {item.completed}</li>
            ))}
          </ol>
        </div>
      ))}
    </div>
  );
}

export default ShowAll;
