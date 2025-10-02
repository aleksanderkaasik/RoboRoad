// DeleteConfirmationModal.js
import React from 'react';

const DeleteConfirmationModal = ({ node, onConfirm, onCancel }) => {
    if (!node) return null;

    return (
        <div className="modal-overlay">
            <div className="modal-content">
                <h1>Are you sure you want to delete this Node?</h1>
                <p><strong>{node.NodeName}</strong></p>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        onConfirm(node.NodeId); // Confirm deletion
                    }}
                >
                    <div className="modal-buttons">
                        <button type="submit">Yes, Delete</button>
                        <button type="button" onClick={onCancel}>Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default DeleteConfirmationModal;
