import React, { useState } from 'react';

const Editing = ({ node, onUpdate, onCancel }) => {
    if (!node) return null;

    const [updatedNode, setUpdatedNode] = useState({
        NodeName: node.NodeName,
        NodeAddress: node.NodeAddress,
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setUpdatedNode(prev => ({
            ...prev,
            [name]: value,
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await fetch(`http://roboroad.loc/api/nodes/${node.NodeId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(updatedNode),
            });

            if (!response.ok) {
                throw new Error('Failed to update node');
            }

            await onUpdate();  // Refresh parent data
            onCancel();        // Close modal

        } catch (error) {
            console.error('Error updating node:', error);
            // Optional: Add error handling UI
        }
    };

    return (
        <div className="modal-overlay">
            <div className="modal-content">
                <h1>Edit Node</h1>
                <form onSubmit={handleSubmit}>
                    <div>
                        <label htmlFor="NodeName">Node Name:</label>
                        <input
                            type="text"
                            name="NodeName"
                            value={updatedNode.NodeName}
                            onChange={handleChange}
                            required
                        />
                    </div>
                    <div>
                        <label htmlFor="NodeAddress">Node Address:</label>
                        <input
                            type="text"
                            name="NodeAddress"
                            value={updatedNode.NodeAddress}
                            onChange={handleChange}
                            required
                        />
                    </div>
                    <div className="modal-buttons">
                        <button type="submit">Update</button>
                        <button type="button" onClick={onCancel}>Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Editing;
