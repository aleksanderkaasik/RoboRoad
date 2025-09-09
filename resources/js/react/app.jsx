import React from 'react';
import ReactDOM from 'react-dom/client';

import Sidebar from './components/Sidebar.jsx';

import './app.css';

function App() {
    return (
        <div className="App">
            <Sidebar />
        </div>
    );
}

ReactDOM.createRoot(document.getElementById('app')).render(<App />);
