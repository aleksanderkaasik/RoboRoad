import React, { useState, useEffect } from 'react';

const TabContent = ({ activeTab, data, selectedNode }) => {
    const [systemInfo, setSystemInfo] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        let interval;

        const fetchSystemInfo = async () => {
            if (activeTab !== 0 || !selectedNode?.NodeAddress) return;

            setLoading(true);
            setError(null);
            setSystemInfo(null); // Optional: clear old data

            try {
                const response = await fetch(`http://${selectedNode.NodeAddress}/system_info`);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();
                setSystemInfo(data);
            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        // Initial fetch if on Tab 3 and node is selected
        if (activeTab === 0 && selectedNode?.NodeAddress) {
            fetchSystemInfo();

            // Set up interval for auto-refresh every 10 minutes
        }

        // Cleanup interval on tab/node change or unmount
        return () => {
            if (interval) clearInterval(interval);
        };
    }, [activeTab, selectedNode]);

    return (
        <div className="content-body">
            {activeTab === 0 && (
                <div>
                    <h2 className='main-content-title'>System Info</h2>

                    {!selectedNode && <p>No node selected.</p>}

                    {selectedNode && (
                        <div>
                            {loading && <p>Loading...</p>}
                            {error && <p style={{ color: 'red' }}>Error: {error}</p>}
                            {systemInfo && (
                                <pre style={{ background: '#111', color: '#fff', padding: '1em', borderRadius: '8px' }}>
                                    {JSON.stringify(systemInfo, null, 2)}
                                </pre>
                            )}
                        </div>
                    )}
                </div>
            )}
            {activeTab === 1 && (
                <div>
                    <h2 className='main-content-title'>Video stream</h2>

                    {!selectedNode && <p>No video available</p>}

                    {selectedNode && (
                        <div>
                            <img key={selectedNode.NodeId} src={`http://${selectedNode.NodeAddress}/video_feed`} alt="Failed connected" />
                        </div>
                    )}
                </div>
            )}

        </div>
    );
};

export default TabContent;
