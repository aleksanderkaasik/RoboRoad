import React from 'react';

const Tabs = ({ activeTab, onTabClick }) => {
    const tabList = ['Tab 1', 'Tab 2'];
    return (
        <div className="tab-menu">
            <div className="tabs">
                {tabList.map((tab, idx) => (
                    <div
                        key={idx}
                        className={`tab ${activeTab === idx ? 'active' : ''}`}
                        onClick={() => onTabClick(idx)}
                    >
                        {tab}
                    </div>
                ))}
            </div>
            <button className="login-button">Login</button>
        </div>
    );
};

export default Tabs;
