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
 * @param value
 * @returns {JSX.Element}
 * @constructor
 */
function UserInput ({
                        placeholder,
                        error,
                        inputRef,
                        buttonOnClick,
                        value = '',
                        isSearch= false,
                        onSearchChange,
                        showButton = true}
) {
    return (
        <div className="input-wrapper">
            <div className="input-inner">
                <input
                    placeholder={placeholder}
                    type={isSearch?"search":"text"}
                    onClick={(e) => {
                        e.stopPropagation()
                    }}
                    defaultValue={value}
                    onChange={isSearch?onSearchChange:null}
                    className={"ToDo-input" + (showButton && error !== null ? " ToDo-input-error" : "")}
                    ref={inputRef}
                />

                {showButton ?<Button message="ADD" onClick={buttonOnClick}/> : null}
            </div>
            {showButton?<div className="ToDo-error">{error}</div> : null}
        </div>
    );
}

export default UserInput;