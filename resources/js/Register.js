import React, { useState } from 'react';
import axios from 'axios';

const Register = () => {
    const [state, setState] = useState({
        name: '',
        email: '',
        password: '',
        successMessage: null
    });

    const handleChange = (event) => {
        const { id, value } = event.target
        setState(prevState => ({
            ...prevState,
            [id] : value
        }))
    }

    const handleSubmitClick = (event) => {
        event.preventDefault();
        const payload = {
            "name": state.name,
            "email": state.email,
            "password": state.password,
        }

        axios.post('http://localhost:8000/api/register', payload)
        .then(function (response) {
            if(response.status === 200){
                setState(prevState => ({
                    ...prevState,
                    'successMessage' : 'Registration successful. Redirecting to home page..'
                }));
            }
        })
        .catch(function (error) {
            console.log(error);
        });    
    }

    return(
        <div className="card">
            <form>
                <div className="form-group">
                    <label htmlFor="name">Name</label>
                    <input type="text" 
                        className="form-control" 
                        id="name" 
                        placeholder="Enter Name" 
                        value={state.name}
                        onChange={handleChange}
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="email">Email address</label>
                    <input type="email" 
                        className="form-control" 
                        id="email" 
                        aria-describedby="emailHelp" 
                        placeholder="Enter email" 
                        value={state.email}
                        onChange={handleChange} 
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="password">Password</label>
                    <input type="password" 
                        className="form-control" 
                        id="password" 
                        placeholder="Password"
                        value={state.password}
                        onChange={handleChange} 
                    />
                </div>
                <button 
                    type="submit" 
                    className="btn btn-primary"
                    onClick={handleSubmitClick}
                >Submit</button>
            </form>
        </div>
    )
}

export default Register;
