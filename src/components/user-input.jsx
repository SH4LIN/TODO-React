/**
 * This file is used to create the user input component for the TODO List.
 */

import './user-input.css'
import Button from "./button";

/**
 * This function is used to create the input field for the TODO List.
 *
 * @param error
 * @param todoInput
 * @param buttonOnClick
 * @param isUpdate
 * @returns {JSX.Element}
 * @constructor
 */
function UserInput ({placeholder, error, inputRef, buttonOnClick, isUpdate,isSearch= false,onSearchChange}) {
    return (
        <div className="ToDo-list-container">
            <div className={"ToDo-input-container"}>
                <input
                    placeholder={placeholder}
                    type="text"
                    onChange={isSearch?onSearchChange:null}
                    className={"ToDo-input" + (!isSearch && error !== null ? " ToDo-input-error" : "")}
                    ref={inputRef}
                />

                {!isSearch ?<Button message={isUpdate ? "UPDATE" : "ADD"} onClick={buttonOnClick}/> : null}
            </div>
            {!isSearch?<div className="ToDo-error">{error}</div> : null}
        </div>
    );
}

export default UserInput;