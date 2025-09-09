import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

import Sidebar from './components/sidebar.jsx';
import MainContent from './components/MainContent.jsx';

import './app.css';

function App() {

    const [laravelData, setLaravelData] = useState([]);
    const [selectedNode, setSelectedNode] = useState(null);

    useEffect(() => {
        if (window.LaravelData) {
            setLaravelData(window.LaravelData);
        }
    }, []);

    return (
        <div className="App">
            <Sidebar
                data={laravelData}
                onNodeSelect={setSelectedNode}
                selectedNode={selectedNode}
            />
            <MainContent data={laravelData} selectedNode={selectedNode} />
        </div>
    );
}

ReactDOM.createRoot(document.getElementById('app')).render(<App />);
