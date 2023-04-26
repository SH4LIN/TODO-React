import './user-input.css'

/**
 * This function is used to create the input field for the TODO List.
 *
 * @param error
 * @param todoInput
 * @param addTask
 * @param isUpdate
 * @returns {JSX.Element}
 * @constructor
 */
function UserInput ({error, todoInput, addTask, isUpdate}) {
    return (
        <div className="ToDo-list-container">
            <div className={"ToDo-input-container"}>
                <input type="text" className={"ToDo-input" + (error !== null ? " ToDo-input-error" : "")} ref={todoInput}/>
                <button className="ToDo-add" onClick={addTask}>{ isUpdate ? "UPDATE" : "ADD" }</button>
            </div>
            <div className="ToDo-error">{error}</div>
        </div>
    );
}

export default UserInput;