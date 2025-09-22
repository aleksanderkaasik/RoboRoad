import React, { useState } from 'react';

import TabContent from './tabContent.jsx';
import Tabs from './tabs.jsx';

const MainContent = ({data, selectedNode }) => {
    const [activeTab, setActiveTab] = useState(0);
    const extractedNodes = data?.data || [];

    return (
        <div className="main-content">
            <Tabs activeTab={activeTab} onTabClick={setActiveTab} />
            <TabContent activeTab={activeTab} selectedNode={selectedNode} />
        </div>
    );
};

export default MainContent;
