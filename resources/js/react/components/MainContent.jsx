import React, { useState } from 'react';

import TabContent from './tabContent.jsx';
import Tabs from './tabs.jsx';

const MainContent = () => {
    const [activeTab, setActiveTab] = useState(0);

    return (
        <div className="main-content">
            <Tabs activeTab={activeTab} onTabClick={setActiveTab} />
            <TabContent activeTab={activeTab} />
        </div>
    );
};

export default MainContent;
