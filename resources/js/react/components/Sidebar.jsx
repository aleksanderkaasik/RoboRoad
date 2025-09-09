import React from "react";

const Sidebar = () => {
    return (
        <div className="Sidebar">
            <div className="sidebar-content">
                {Array.from({ length: 40 }).map((_, idx) => (
                    <div key={idx} className="sidebar-item">Item {idx + 1}</div>
                ))}
            </div>
        </div>
    );
};

export default Sidebar;
