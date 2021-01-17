'''Count the number of valleys in specific steps'''

def count_steps(starting_step, steps_in_path):
    '''This will calculate the number steps taken until we reach sea level'''

    start = 1;  # This is the distance from sea level
    hold_val = steps_in_path[starting_step] # This is the value we are looking for
    starting_step += 1


    while starting_step < len(steps_in_path):
        if start == 0:
            break

        if steps_in_path[starting_step] == hold_val:
            start += 1
        else:
            start -= 1

        starting_step += 1

    is_pos = False
    if start == 0:
        is_pos = True

    return is_pos, starting_step

def countValleys(steps, path):
    '''Counts the number of valleys and hills in a given path taken'''

    start = 0;
    current_step = 0    # Current step is the index of the the step being taken
    h_count = 0
    v_count = 0

    while current_step < steps:
        # What is the first step taken
        if (path[current_step] == 'D'):
            is_hill, steps_taken = count_steps(current_step, path)
            current_step += steps_taken

            if is_hill:
                h_count+=1
            print(is_hill, steps_taken)
        elif path[current_step] == 'U':
            is_valley, steps_taken = count_steps(current_step, path)
            current_step += steps_taken

            if is_valley:
                v_count+=1
            print(is_valley, steps_taken)

    print(h_count, v_count)



if __name__ == '__main__':
    countValleys(8, "DDUDDUUDUU")
    # countValleys(8, ['U','D','D','D','U', 'D','U', 'U'])
