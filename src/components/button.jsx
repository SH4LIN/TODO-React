/**
 * This file is used to clear all the tasks from the TODO List.
 */

import './button.css'

/**
 * This function is used to create the clear all button for the TODO List.
 *
 * @param clearAll
 * @returns {JSX.Element}
 */
function Button ({message,onClick}) {
    return (
        <button className="ToDo-button" onClick={onClick}>{message}</button>
    );
}

export default Button;