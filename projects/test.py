
def freq_number(a, num):
    freq = 0
    for i in a:
        if i == num:
            freq += 1
    return freq


def solution(a):
    print("a is the number", a)


    # First step get the individual instances of the numbers

    distinct = set(a)
    print(distinct)

    # Second get the frequency each instance occurs in the array.
    dist_set = dict()
    for num in distinct:
        dist_set[num] = freq_number(a, num)

    # calculate the lowest number of steps it takes for each candidate.
    print(dist_set)

    step_count = dict()
    for key, value in dist_set.items():
        print('key = ', key)
        tmp = 0
        for n in distinct:
            # skip if this is the same key as in the set
            if key == n:
                continue
            # Get the difference between the two
            dif = key - n

            # make sure that its a positive number
            if dif < 0:
                dif *= -1
            # Multiply the difference by the frequency
            dif *= dist_set[n]
            # Store it for later
            tmp += dif

        # Save it for later use.
        step_count[key] = tmp

    print(step_count)



    pass


if __name__ == '__main__':
    solution([3,3,3])
