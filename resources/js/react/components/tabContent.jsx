import React, { useState, useEffect } from 'react';
import Sidebar from "./sidebar.jsx";
import MainContent from "./MainContent.jsx";

const TabContent = ({ activeTab }) => {
    const [systemInfo, setSystemInfo] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    return (
        <div className="content-body">
            {activeTab === 0 && (
                <div>
                    <h2>Tab 1 Content</h2>
                    <p>This is the content of Tab 1.</p>
                </div>
            )}

            {activeTab === 1 && (
                <div>
                    <h2>Tab 2 Content</h2>
                    <p>This is the content of Tab 2.</p>
                </div>
            )}
        </div>
    );
};

export default TabContent;
