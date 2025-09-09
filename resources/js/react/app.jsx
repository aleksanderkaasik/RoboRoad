import React from 'react';
import ReactDOM from 'react-dom/client';

import Sidebar from './components/sidebar.jsx';
import MainContent from './components/MainContent.jsx';

import './app.css';

function App() {
    return (
        <div className="App">
            <Sidebar />
            <MainContent />
        </div>
    );
}

ReactDOM.createRoot(document.getElementById('app')).render(<App />);
