import React, { useEffect } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

function Logout() {
    const navigate = useNavigate();

    useEffect(() => {
        const logout = async () => {
            const token = sessionStorage.getItem('token');
            const config = {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
            };
            try {
                // Make logout request
                await axios.post('http://127.0.0.1:8000/api/logout', {}, config);
                
                // Clear the token from sessionStorage
                sessionStorage.removeItem('token');
                navigate('/login');
            } catch (error) {
                console.error(error);
            } finally {
                // Always navigate back to login, even if the logout request failed
                navigate('/login');
            }
        };
        logout();
    }, [navigate]);

    return (
        <div className='App'>
            <h1>Logged Out</h1>

            <p>Login Again</p>
        </div>
    );
}

export default Logout;
