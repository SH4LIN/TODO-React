import {useEffect, useRef, useState} from 'react'
import './App.css';
import List from './list'

/**
 * This function is used to create a TODO App.
 *
 * @returns {JSX.Element}
 * @constructor
 */
function ToDo() {
    const [toDoList, setToDoList] = useState(()=> {
        const storedItems = JSON.parse(localStorage.getItem('toDoList'));
        if (storedItems) {
            return storedItems;
        }
        return [];
    });
    const [isUpdate, setIsUpdate] = useState(false);
    const [updateId, setUpdateId] = useState(0);
    const [error, setError] = useState(null);
    const todoInput = useRef(null);

    useEffect(() => {
        localStorage.setItem('toDoList', JSON.stringify(toDoList));
    } , [toDoList]);

    useEffect(() => {
        todoInput.current.focus();
    }, [isUpdate]);

    const addTask = () => {
        const inputValue = todoInput.current.value;
        if (inputValue === '') {
            setError("Please enter a task")
            return;
        } else {
            setError(null);
        }
        if(isUpdate) {
            const newList = toDoList.map(item => {
                if (item.id === updateId) {
                    console.log(item.value, inputValue)
                    if (item.value === inputValue) {
                        setError("Please enter new value")
                    } else {
                        setError(null);
                        item.value = inputValue;
                    }
                }
                return item;
            })
            setToDoList( newList )
            setIsUpdate(false);
            setUpdateId(0);
        } else {
            setToDoList(list => [
                    {
                        id: Math.max(...list.map(item => item.id), 0) + 1,
                        value: inputValue,
                        done: false
                    },
                    ...list,
                ]
            )
        }
        todoInput.current.value = '';
    }

    const checkTask = (id) => {
        setToDoList(
            toDoList.map(item => {
                if (item.id === id) {
                    item.done = !item.done;
                }
                return item;
            })
        )
    }

    const deleteTask = (id) => {
        setToDoList( list =>  list.filter(item => item.id !== id))
    }

    const editTask = (id, value) => {
        todoInput.current.value = value;
        setUpdateId(id);
        setIsUpdate(true);
    }

    const remainingTasks = toDoList.filter(item => !item.done);
    const completedTasks = toDoList.filter(item => item.done);

    return (
        <div className="ToDo-container">
            <h1 className="ToDo-app-heading">{"ToDo App"}</h1>
            <div className="ToDo">
                <List listName="Tasks" list={remainingTasks} checkTask={checkTask} deleteTask={deleteTask} editTask={editTask} />
                <div className={"ToDo-input-container"}>
                    <input type="text" className={"ToDo-input" + (error !== null ? " ToDo-input-error" : "")} ref={todoInput}/>
                    <button className="ToDo-add" onClick={addTask}>{ isUpdate ? "UPDATE" : "ADD" }</button>
                </div>
                <div className="ToDo-error">{error}</div>
                <List listName="Completed Tasks" list={completedTasks} />
            </div>
        </div>
    );
}

export default ToDo;
