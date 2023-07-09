import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

function Login() {
    const [formData, setFormData] = useState({
        email: '',
        password: ''
    });

    const [statusMessage, setStatusMessage] = useState('');
    const [token, setToken] = useState('');

    const { email, password } = formData;

    const navigate = useNavigate(); 

    const onChange = e => setFormData({ ...formData, [e.target.name]: e.target.value });

    const onSubmit = async e => {
        e.preventDefault();

        const config = {
            headers: {
                'Content-Type': 'application/json',
            },
        };
        const body = JSON.stringify({ email, password });

        try {
            const response = await axios.post('http://127.0.0.1:8000/api/login', body, config);
            
            // setToken(response.data.access_token);  // Store the token into state
            sessionStorage.setItem('token', response.data.access_token); 

            console.log(response.data);

            setStatusMessage(`Successfully Logged in.`);

            navigate('/showall');

        } catch (error) {
            console.error(error);
            setStatusMessage(`Login failed.`);
        }
    };

    return (
        <div className='App'>
            <h1>Login</h1>
            <p>{statusMessage}</p>
            <form onSubmit={e => onSubmit(e)}>
                <div>
                    <input 
                        type="email" 
                        placeholder="Email" 
                        name="email" 
                        value={email} 
                        onChange={e => onChange(e)} 
                        required 
                    />
                </div>
                <div>
                    <input 
                        type="password" 
                        placeholder="Password" 
                        name="password" 
                        value={password} 
                        onChange={e => onChange(e)} 
                        required 
                    />
                </div>
                <input type="submit" value="Login" />
            </form>
        </div>
    );
}

export default Login;
