/**
 * This file contains the main component for the TODO App.
 */

import {useEffect, useRef, useState} from 'react'
import './App.css';
import List from './components/list'
import UserInput from "./components/user-input";
import Button from "./components/button";

/**
 * This function is used to create a TODO App.
 *
 * @returns {JSX.Element}
 */
function ToDo() {
    // Creating TODO List State from the local storage if it exists. Otherwise creating an empty list.
    const [toDoList, setToDoList] = useState(()=> {
        const storedItems = JSON.parse(localStorage.getItem('toDoList'));
        if (storedItems) {
            return storedItems;
        }
        return [];
    });
    // Created a state to check if the task is to be updated.
    const [isUpdate, setIsUpdate] = useState(false);
    // Created a state to store the id of the task to be updated.
    const [updateId, setUpdateId] = useState(0);
    // Created a state to store the error message.
    const [error, setError] = useState(null);
    // Created a reference to the input field.
    const taskInputRef = useRef(null);
    // Created a reference to the search input field.
    const searchInputRef = useRef(null);
    // Created a state to check if the search is active.
    const [isSearching, setIsSearching] = useState(false);
    // Create a state to store the search value.
    const [searchValue, setSearchValue] = useState('');

    // Saving the TODO List in the local storage.
    useEffect(() => {
        localStorage.setItem('toDoList', JSON.stringify(toDoList));
    } , [toDoList]);

    // Setting focus on the input field if the task is to be updated.
    useEffect(() => {
        taskInputRef.current.focus();
    }, [isUpdate]);

    /**
     * This function is used to add or update a task to the TODO List.
     */
    const addTask = () => {
        const inputValue = taskInputRef.current.value;
        if (inputValue === '') {
            setError("Please enter a task!")
            return;
        } else {
            setError(null);
        }
        // Updating the task if the task is to be updated.
        if(isUpdate) {
            const newList = toDoList.map(item => {
                if (item.id === updateId) {
                    console.log(item.value, inputValue)
                    if (item.value === inputValue) {
                        setError("Please enter new value!")
                    } else {
                        setError(null);
                        // Updating the task.
                        item.value = inputValue;
                    }
                }
                return item;
            })
            setToDoList( newList )
            setIsUpdate(false);
            setUpdateId(0);
        } else {
            // Adding the task to the TODO List.
            setToDoList([
                    {
                        id: Math.max(...toDoList.map(item => item.id), 0) + 1,
                        value: inputValue,
                        done: false
                    },
                    ...toDoList,
                ]
            )
        }
        taskInputRef.current.value = '';
    }

    /**
     * This function is used to check or uncheck a task.
     *
     * @param id
     */
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

    /**
     * This function is used to delete a task.
     *
     * @param id
     */
    const deleteTask = (id) => {
        setToDoList( list =>  list.filter(item => item.id !== id))
    }

    /**
     * This function is used to edit a task.
     *
     * @param id
     * @param value
     */
    const editTask = (id, value) => {
        taskInputRef.current.value = value;
        setUpdateId(id);
        setIsUpdate(true);
    }

    /**
     * This function is used to clear all the tasks.
     */
    const clearAllToDoTask = () => {
        setToDoList( list => list.filter(item => item.done));
    }

    /**
     * This function is used to clear all the completed tasks.
     */
    const clearAllCompletedTask = () => {
        setToDoList( list => list.filter(item => !item.done));
    }

    const onSearchChange = () => {
        const searchValue = searchInputRef.current.value;
        if(searchValue === '') {
            setIsSearching(false);
        } else {
            setIsSearching(true);
            setSearchValue(searchValue)
        }
    }

    const remainingTasks = toDoList.filter(item => !item.done);
    const completedTasks = toDoList.filter(item => item.done);
    const searchResults = toDoList.filter(item => item.value.toLowerCase().includes(searchValue.toLowerCase()));

    return (
        <div className="ToDo-container">
            <h1 className="ToDo-app-heading">{"ToDo App"}</h1>
            <UserInput placeholder="Search" inputRef={searchInputRef} isSearch={true} onSearchChange={onSearchChange} />
            {isSearching?<List listName="Search Results"
                               list={searchResults}
                               checkTask={checkTask}
                               deleteTask={deleteTask}
                               editTask={editTask}
            />:null}
            <div className="ToDo">
                {/*Displaying the TODO List.*/}
                <List
                    listName="Tasks"
                    list={remainingTasks}
                    checkTask={checkTask}
                    deleteTask={deleteTask}
                    editTask={editTask}
                    clearAll={<Button onClick={clearAllToDoTask} message="Clear all TODO tasks"/>}
                />
                <UserInput placeholder="Enter Task" inputRef={taskInputRef} buttonOnClick={addTask} error={error} isUpdate={isUpdate} />
                {/*Displaying Completed List*/}
                <List
                    listName="Completed Tasks"
                    list={completedTasks}
                    checkTask={checkTask}
                    clearAll={<Button onClick={clearAllCompletedTask} message="Clear all completed tasks"/>}
                />
            </div>
        </div>
    );
}

export default ToDo;
