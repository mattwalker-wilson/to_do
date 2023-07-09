import React, { useState, useEffect   } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import NavBar  from '../Common/NavBar';
import { FaTimes, FaCheck, FaPlus, FaTrash, FaEdit } from 'react-icons/fa';


function ShowAll() {
  const [lists, setLists] = useState([]);
  const token = sessionStorage.getItem('token');

  const fetchLists = async () => {
    const token = sessionStorage.getItem('token');
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

  const updateCompletedStatus = async (listId, itemId, completedStatus) => {
    const token = sessionStorage.getItem('token');
    const config = {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
    };

    const body = JSON.stringify({ completed: completedStatus });

    try {
      await axios.patch(`http://127.0.0.1:8000/api/todolists/${listId}/todoitems/${itemId}`, body, config);
      // After successful update, fetch the lists again to reflect changes in the UI
      fetchLists();
    } catch (error) {
      console.error('An error occurred while updating the item:', error);
    }
  };    

  const deleteToDoItem = async (listId, itemId) => {
    const token = sessionStorage.getItem('token');
    const config = {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
    };
  
    try {
      await axios.delete(`http://127.0.0.1:8000/api/todolists/${listId}/todoitems/${itemId}`, config);
      // After successful deletion, fetch the lists again to reflect changes in the UI
      fetchLists();
    } catch (error) {
      console.error('An error occurred while deleting the item:', error);
    }
  };
  
  const deleteList = async (listId) => {
    const token = sessionStorage.getItem('token');
    const config = {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
    };
  
    try {
      await axios.delete(`http://127.0.0.1:8000/api/todolists/${listId}`, config);
      // After successful deletion, fetch the lists again to reflect changes in the UI
      fetchLists();
    } catch (error) {
      console.error('An error occurred while deleting the list:', error);
    }
  };
  

  useEffect(() => {
    fetchLists();
  }, [token]);

  return (
    <div>
      <NavBar />
      {lists.map(list => (
        <div key={list.id}>
          <h2>      
            <span 
                title='Click to delete list' 
                onClick={() => {if (window.confirm('Are you sure you wish to delete this list and all the items on this list?')) deleteList(list.id)}}
              >
                <FaTrash style={{ color: "red" }} />
              </span>
            &nbsp;
            {list.name} 
            &nbsp;
            <Link title='Add To Do Item to this List' to={`/additem/${list.id}`}><FaPlus style={{ color: "blue" }} /></Link>
          </h2>
          <ol>
            {list.to_do_items.map(item => (
              <li key={item.id}><div className='text-lg text-bold'>
                <span 
                title='Click to delete' 
                onClick={() => deleteToDoItem(list.id, item.id)}
                ><FaTrash style={{ color: "red" }} /></span>
              {item.title}  &nbsp; 
              <span title={ `Click to mark as ${item.completed === 0 ?'Completed':'Pending'}` } onClick={() => updateCompletedStatus(list.id, item.id, item.completed === 1 ? 0 : 1)}>
                  {item.completed === 1 ? <FaCheck style={{ color: "green" }} /> : <FaTimes style={{ color: "red" }} />}
              </span>
              </div>
              <span className='text-light-emphasis'>{item.description}</span>
              </li>
            ))}
          </ol>
        </div>
      ))}
    </div>
  );
}

export default ShowAll;
