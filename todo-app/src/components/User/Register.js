import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

function Register() {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: '',
    });

    const [statusMessage, setStatusMessage] = useState(''); 

    const { name, email, password } = formData;

    const navigate = useNavigate(); 

    const onChange = (e) => setFormData({ ...formData, [e.target.name]: e.target.value });

    const onSubmit = async (e) => {
        e.preventDefault();
        const config = {
            headers: {
                'Content-Type': 'application/json',
            },
        };
        const body = JSON.stringify({ name, email, password });
        try {
            const response = await axios.post('http://127.0.0.1:8000/api/register', body, config);
            
            console.log(response.data);
            
            setStatusMessage(`User ${name} created successfully.`);

            navigate('/todolists');

        } catch (error) {
            console.error(error);
            setStatusMessage('An error occurred. Please try again.');
        }
    };

    return (
        <div>
            <h1>Register</h1>
            <p>{statusMessage}</p>
            <form onSubmit={(e) => onSubmit(e)}>
                <div>
                    <input type="text" placeholder="Name" name="name" value={name} onChange={(e) => onChange(e)} required />
                </div>
                <div>
                    <input type="email" placeholder="Email" name="email" value={email} onChange={(e) => onChange(e)} required />
                </div>
                <div>
                    <input type="password" placeholder="Password" name="password" value={password} onChange={(e) => onChange(e)} required />
                </div>
                <input type="submit" value="Register" />
            </form>
        </div>
    );
}

export default Register;
