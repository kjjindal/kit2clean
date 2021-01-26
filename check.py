def check(a,k):
    i=1
    count=0
    while (i>0 and count<k):
        if i in a:
            print('hai')
        else:
            print('nhi hai')
            count=count+1
        i+=1
    
    return i


if __name__ == "__main__":
    a=[1,2]
    k=1
    print(check(a,k))