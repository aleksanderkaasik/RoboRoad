import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

import Sidebar from './components/sidebar.jsx';
import MainContent from './components/MainContent.jsx';

import './app.css';

function App() {
    const [laravelData, setLaravelData] = useState([]);
    const [selectedNode, setSelectedNode] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        // Fetch the node data from the API
        const fetchNodes = async () => {
            try {
                const response = await fetch('http://roboroad.loc/api/nodes');
                const data = await response.json();

                if (!data.success) {
                    throw new Error(`HTTP ${data.message}`);
                }
                setLaravelData(data.nodes);
            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchNodes();
    }, []);

    if (loading) {
        return <div>Loading...</div>;
    }

    if (error) {
        return <div style={{ color: 'red' }}>Error: {error}</div>;
    }

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
