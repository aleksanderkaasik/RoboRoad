import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

import Sidebar from './components/sidebar.jsx';
import MainContent from './components/MainContent.jsx';

import './app.css';

function App() {
    const [laravelData, setLaravelData] = useState([]);
    const [selectedNode, setSelectedNode] = useState(null);

    // Consolidated function to fetch node data
    const fetchNodes = async () => {
        try {
            const response = await fetch('http://roboroad.loc/api/nodes');

            const data = await response.json();

            if (!data.success) {
                throw new Error('Failed to fetch data');
            }

            setLaravelData(data.nodes);  // Update the state with the fetched data
        } catch (error) {
            console.error('Error fetching nodes:', error);
        }
    };

    // Fetch data on initial load
    useEffect(() => {
        fetchNodes();
    }, []);

    // Function to refresh data manually
    const refreshData = () => {
        fetchNodes();
    };

    return (
        <div className="App">
            <Sidebar
                data={laravelData}
                onNodeSelect={setSelectedNode}
                selectedNode={selectedNode}
                refreshData={refreshData}
            />
            <MainContent data={laravelData} selectedNode={selectedNode} />
        </div>
    );
}

ReactDOM.createRoot(document.getElementById('app')).render(<App />);
