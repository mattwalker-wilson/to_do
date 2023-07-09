import React from 'react';
import { Link } from 'react-router-dom';

function Navbar() {
    return (
        <nav>
            <ul>
                <li><Link to="/showall">Show All Lists</Link></li>
                <li><Link to="/create">Create New List</Link></li>
                <li><Link to="/logout">Logout</Link></li>
            </ul>
        </nav>
    );
}

export default Navbar;
